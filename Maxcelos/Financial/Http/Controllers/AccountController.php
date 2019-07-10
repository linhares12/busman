<?php

namespace Maxcelos\Financial\Http\Controllers;

use Nwidart\Modules\Routing\Controller;
use Maxcelos\Financial\Entities\Account;
use Maxcelos\Financial\Http\Requests\AccountRequest;
use Maxcelos\Financial\Services\AccountService;

class AccountController extends Controller
{
    protected $accountService;

    function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        $this->authorize('index', Account::class);

        return response()->json(Account::jsonPaginate(), 200);
    }

    public function store(AccountRequest $request)
    {
        $this->authorize('create', Account::class);

        $account = $this->accountService->make($request->all());

        return response()->json($account->toArray(), 201);
    }

    public function show($account)
    {
        $account = $this->accountService->get($account);

        $this->authorize('view',  $account);

        return response()->json($account->toArray(), 200);
    }

    public function update(AccountRequest $request, $account)
    {
        $this->authorize('update', $this->accountService->get($account));

        $account = $this->accountService->update($account, $request->all());

        return response()->json($account->toArray(), 200);
    }

    public function destroy($account)
    {
        $this->authorize('delete', $this->accountService->get($account));

        $this->accountService->delete($account);

        return response()->json(['message' => 'The role has been deleted'], 204);
    }
}
