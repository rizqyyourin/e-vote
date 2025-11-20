<?php

namespace App\Http\Controllers;

use App\Models\Voting;
use Barryvdh\DomPDF\Facade\Pdf;

class VotingPdfController extends Controller
{
    /**
     * Export voting results to PDF
     */
    public function exportResults(Voting $voting)
    {
        // Check authorization - only admin who created voting can export
        if (auth()->id() !== $voting->admin_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        // Prepare data
        $data = [
            'voting' => $voting,
            'totalVotes' => $voting->votes()->count(),
            'showAudit' => true, // Admin dapat melihat audit trail
        ];

        // Generate PDF
        $pdf = Pdf::loadView('pdfs.voting-results', $data)
            ->setPaper('a4')
            ->setOption('margin-top', 0)
            ->setOption('margin-right', 0)
            ->setOption('margin-bottom', 0)
            ->setOption('margin-left', 0);

        return $pdf->download('voting-results-' . $voting->slug . '.pdf');
    }

    /**
     * Export voting results without audit trail (for voters)
     */
    public function exportResultsPublic(Voting $voting)
    {
        // Prepare data without audit trail
        $data = [
            'voting' => $voting,
            'totalVotes' => $voting->votes()->count(),
            'showAudit' => false, // Voters cannot see audit trail
        ];

        // Generate PDF
        $pdf = Pdf::loadView('pdfs.voting-results', $data)
            ->setPaper('a4')
            ->setOption('margin-top', 0)
            ->setOption('margin-right', 0)
            ->setOption('margin-bottom', 0)
            ->setOption('margin-left', 0);

        return $pdf->download('voting-results-' . $voting->slug . '.pdf');
    }
}
