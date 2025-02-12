<?php

namespace App\Http\Controllers\Boarders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Documents;
class DocumentController extends Controller
{
    public function index()
    {
        return view('boarders.documents');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'psa_birth_cert' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'boarder_valid_id' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'boarder_selfie' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'guardian_valid_id' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'guardian_selfie' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $boarder = auth('boarders')->user();

        if ($boarder && $boarder->last_name) {
            $boarderLastName = $boarder->last_name;
        } else {
            return redirect()->route('boarders.documents')->with('error', 'Boarder data not found.');
        }

        $folderPath = 'documents/' . $boarderLastName;

        $handleFileUpload = function ($file, $fileName, $folderPath) {
            if ($file) {
                $fileExtension = $file->getClientOriginalExtension();
                $filePath = $fileName . '.' . $fileExtension;

                if (Storage::disk('public')->exists($folderPath . '/' . $filePath)) {
                    Storage::disk('public')->delete($folderPath . '/' . $filePath);
                }
                return $file->storeAs($folderPath, $filePath, 'public');
            }
            return null;
        };

        $psaBirthCertPath = $handleFileUpload($request->file('psa_birth_cert'), 'psa_birth_cert', $folderPath);
        $boarderValidIdPath = $handleFileUpload($request->file('boarder_valid_id'), 'boarder_valid_id', $folderPath);
        $boarderSelfiePath = $handleFileUpload($request->file('boarder_selfie'), 'boarder_selfie', $folderPath);
        $guardianValidIdPath = $handleFileUpload($request->file('guardian_valid_id'), 'guardian_valid_id', $folderPath);
        $guardianSelfiePath = $handleFileUpload($request->file('guardian_selfie'), 'guardian_selfie', $folderPath);
        $updateData = ['email' => $boarder->email];

        if ($psaBirthCertPath) {
            $updateData['psa_birth_cert'] = 'psa_birth_cert.' . pathinfo($psaBirthCertPath, PATHINFO_EXTENSION);
        }

        if ($boarderValidIdPath) {
            $updateData['boarder_valid_id'] = 'boarder_valid_id.' . pathinfo($boarderValidIdPath, PATHINFO_EXTENSION);
        }

        if ($boarderSelfiePath) {
            $updateData['boarder_selfie'] = 'boarder_selfie.' . pathinfo($boarderSelfiePath, PATHINFO_EXTENSION);
        }

        if ($guardianValidIdPath) {
            $updateData['guardian_valid_id'] = 'guardian_valid_id.' . pathinfo($guardianValidIdPath, PATHINFO_EXTENSION);
        }

        if ($guardianSelfiePath) {
            $updateData['guardian_selfie'] = 'guardian_selfie.' . pathinfo($guardianSelfiePath, PATHINFO_EXTENSION);
        }

        Documents::updateOrCreate(
            ['boarder_id' => $boarder->boarder_id],
            $updateData
        );

        return redirect()->route('boarders.documents')->with('success', 'Documents uploaded and updated successfully.');
    }

    public function destroy($document)
    {
        Storage::delete('documents/' . $document);

        return redirect()->route('boarders.documents')->with('success', 'Document deleted successfully.');
    }
}
