<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Triggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
                CREATE TRIGGER amount_trigger_insert AFTER INSERT ON releases
                FOR EACH ROW
                BEGIN
                    IF(NEW.status = 'payd' AND NEW.type = 'receipt') THEN
                        UPDATE accounts SET accounts.amount = accounts.amount+NEW.value WHERE accounts.id = NEW.account;
                    ELSEIF (NEW.status = 'payd' AND NEW.type = 'expense') THEN
                        UPDATE accounts SET accounts.amount = accounts.amount-NEW.value WHERE accounts.id = NEW.account;
                    END IF;

                    IF(NEW.type = 'transfer_in') THEN
                        UPDATE accounts SET accounts.amount = accounts.amount+NEW.value WHERE accounts.id = NEW.account;
                    ELSEIF (NEW.type = 'transfer_out') THEN
                        UPDATE accounts SET accounts.amount = accounts.amount-NEW.value WHERE accounts.id = NEW.account;
                    END IF;
                END
            ");

        DB::unprepared("
                CREATE TRIGGER amount_trigger_update BEFORE UPDATE ON releases
                FOR EACH ROW

                    IF (OLD.type = 'receipt') THEN
                        IF(NEW.account != OLD.account OR NEW.value != OLD.value OR NEW.status != OLD.status) THEN
                            IF(OLD.status = 'payd') THEN
                                UPDATE accounts SET accounts.amount = accounts.amount-OLD.value WHERE accounts.id = OLD.account;
                            END IF;
                            
                            IF(NEW.status = 'payd') THEN
                                UPDATE accounts SET accounts.amount = accounts.amount+NEW.value WHERE accounts.id = NEW.account;
                            END IF;
                        END IF;
                    ELSEIF(OLD.type = 'expense') THEN
                        IF(NEW.account != OLD.account OR NEW.value != OLD.value OR NEW.status != OLD.status) THEN
                            IF(OLD.status = 'payd') THEN
                                UPDATE accounts SET accounts.amount = accounts.amount+OLD.value WHERE accounts.id = OLD.account;
                            END IF;
                            
                            IF(NEW.status = 'payd') THEN
                                UPDATE accounts SET accounts.amount = accounts.amount-NEW.value WHERE accounts.id = NEW.account;
                            END IF;
                        END IF;
                    END IF;

                END
            ");

        DB::unprepared("
                CREATE TRIGGER amount_trigger_delete BEFORE DELETE ON releases
                FOR EACH ROW
                BEGIN
                    IF(OLD.status = 'payd' AND OLD.type = 'receipt') THEN
                        UPDATE accounts SET accounts.amount = accounts.amount-OLD.value WHERE accounts.id = OLD.account;
                    ELSEIF(OLD.status = 'payd' AND OLD.type = 'expense') THEN
                        UPDATE accounts SET accounts.amount = accounts.amount+OLD.value WHERE accounts.id = OLD.account;
                    END IF;
                END
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `amount_trigger_insert`');
        DB::unprepared('DROP TRIGGER `amount_trigger_update`');
        DB::unprepared('DROP TRIGGER `amount_trigger_delete`');
        DB::unprepared('DROP TRIGGER `transfer_trigger_insert`');
    }
}
