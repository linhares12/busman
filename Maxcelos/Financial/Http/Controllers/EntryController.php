<?php

namespace Maxcelos\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maxcelos\Financial\Entities\Entry;
use Maxcelos\Financial\Http\Requests\EntryRequest;
use Maxcelos\Financial\Services\EntryService;
use Nwidart\Modules\Routing\Controller;

class EntryController extends Controller
{
    protected $entryService;

    function __construct(EntryService $entryService)
    {
        $this->entryService = $entryService;
    }

    public function index()
    {
        $this->authorize('index', Entry::class);

        return response()->json(Entry::jsonPaginate(), 200);
    }

    public function store(EntryRequest $request)
    {
        $this->authorize('create', Entry::class);

        $entry = $this->entryService->make($request->all());

        return response()->json($entry->toArray(), 201);
    }

    public function show($entry)
    {
        $entry = $this->entryService->get($entry);

        $this->authorize('view',  $entry);

        return response()->json($entry->toArray(), 200);
    }

    public function update(EntryRequest $request, $entry)
    {
        $this->authorize('update', $this->entryService->get($entry));

        $entry = $this->entryService->update($entry, $request->all());

        return response()->json($entry->toArray(), 200);
    }

    public function destroy($entry)
    {
        $this->authorize('delete', $this->entryService->get($entry));

        $this->entryService->delete($entry);

        return response()->json(['message' => 'The role has been deleted'], 204);
    }
}
