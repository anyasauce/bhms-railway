@extends('layouts.boarderportal')
@section('title', 'Upload Documents')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header text-white text-center py-4 mb-3"
            style="background: linear-gradient(45deg, #007bff, #6610f2);">
            <h3 class="fw-bold">📄 Upload Required Documents</h3>
            <p class="mb-0">Ensure your documents are clear and valid.</p>
        </div>

        <div class="card-body">
            @php
                $boarder = auth('boarders')->user();
                $existingDocuments = \App\Models\Documents::where('boarder_id', $boarder->boarder_id)->first();
            @endphp

            @if($existingDocuments)
                <div class="alert alert-info mb-4">
                    <strong>Documents already uploaded:</strong>
                    <ul>
                        @if($existingDocuments->psa_birth_cert)
                            <li>📜 PSA Birth Certificate: <a
                                    href="{{ Storage::url('documents/' . $boarder->last_name . '/' . $existingDocuments->psa_birth_cert) }}"
                                    target="_blank">View File</a></li>
                        @endif
                        @if($existingDocuments->boarder_valid_id)
                            <li>🆔 Boarder's Valid ID: <a
                                    href="{{ Storage::url('documents/' . $boarder->last_name . '/' . $existingDocuments->boarder_valid_id) }}"
                                    target="_blank">View File</a></li>
                        @endif
                        @if($existingDocuments->boarder_selfie)
                            <li>📸 Boarder's Selfie: <a
                                    href="{{ Storage::url('documents/' . $boarder->last_name . '/' . $existingDocuments->boarder_selfie) }}"
                                    target="_blank">View File</a></li>
                        @endif
                        @if($existingDocuments->guardian_valid_id)
                            <li>👨‍👩‍👧 Guardian's Valid ID: <a
                                    href="{{ Storage::url('documents/' . $boarder->last_name . '/' . $existingDocuments->guardian_valid_id) }}"
                                    target="_blank">View File</a></li>
                        @endif
                        @if($existingDocuments->guardian_selfie)
                            <li>📸 Guardian's Selfie: <a
                                    href="{{ Storage::url('documents/' . $boarder->last_name . '/' . $existingDocuments->guardian_selfie) }}"
                                    target="_blank">View File</a></li>
                        @endif
                    </ul>
                    <p class="mb-0">You can upload new documents to replace the existing ones.</p>
                </div>
            @endif

            <form action=" {{ route('boarders.documents.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="psa_birth_cert" class="form-label fw-bold">📜 Boarder's PSA Birth Certificate
                        (PDF/JPG/PNG/JPEG)</label>
                    <input type="file" class="form-control" id="psa_birth_cert" name="psa_birth_cert"
                        accept=".pdf,.jpg,.jpeg,.png" @if($existingDocuments) @else required @endif>
                </div>

                <div class="mb-4">
                    <label for="boarder_valid_id" class="form-label fw-bold">🆔 Boarder’s Valid ID
                        (PDF/JPG/PNG/JPEG)</label>
                    <input type="file" class="form-control" id="boarder_valid_id" name="boarder_valid_id"
                        accept=".pdf,.jpg,.jpeg,.png" @if($existingDocuments) @else required @endif>
                </div>

                <div class="mb-4">
                    <label for="boarder_selfie" class="form-label fw-bold">📸 Boarder’s Selfie for Valid ID
                        (PDF/JPG/PNG/JPEG)</label>
                    <input type="file" class="form-control" id="boarder_selfie" name="boarder_selfie"
                        accept=".pdf,.jpg,.jpeg,.png" @if($existingDocuments) @else required @endif>
                </div>

                <div class="mb-4">
                    <label for="guardian_valid_id" class="form-label fw-bold">👨‍👩‍👧 Guardian’s Valid ID
                        (PDF/JPG/PNG/JPEG)</label>
                    <input type="file" class="form-control" id="guardian_valid_id" name="guardian_valid_id"
                        accept=".pdf,.jpg,.jpeg,.png" @if($existingDocuments) @else required @endif>
                </div>

                <div class="mb-4">
                    <label for="guardian_selfie" class="form-label fw-bold">📸 Guardian’s Selfie for Valid ID
                        (PDF/JPG/PNG/JPEG)</label>
                    <input type="file" class="form-control" id="guardian_selfie" name="guardian_selfie"
                        accept=".pdf,.jpg,.jpeg,.png" @if($existingDocuments) @else required @endif>
                </div>

                <button type="submit" class="btn btn-success w-100 fw-bold">Upload Documents</button>
            </form>
        </div>
    </div>
</div>
@endsection
