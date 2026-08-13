<?php

namespace App\Http\Controllers;

use App\Models\DocumentStatus;
use App\Http\Requests\StoreDocumentStatusRequest;
use App\Http\Requests\UpdateDocumentStatusRequest;

class DocumentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentStatus $documentStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentStatus $documentStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentStatusRequest $request, DocumentStatus $documentStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentStatus $documentStatus)
    {
        //
    }
}
