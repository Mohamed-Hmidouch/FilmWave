<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    /**
     * @var CommentService
     */
    protected $commentService;
    
    /**
     * Constructeur du contrôleur
     * 
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    
    /**
     * Afficher la page de gestion des commentaires
     * 
     * Cette méthode affiche tous les commentaires du système avec des options
     * pour les filtrer, les approuver, les rejeter ou les supprimer.
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $comments = $this->commentService->getAllComments();
        return view('admin.comments.index', compact('comments'));
    }
    
    /**
     * Delete a comment
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $comment = \App\Models\Comment::findOrFail($id);
            $this->commentService->delete($id, 0, true); // Pass true as third parameter to bypass user check
            
            // For AJAX requests, return JSON response
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Comment deleted successfully'
                ]);
            }
            
            // For regular requests, redirect
            return redirect()->route('admin.comments.index')
                ->with('success', 'Comment deleted successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting comment: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.comments.index')
                ->with('error', 'Error deleting comment: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete a user and all their comments
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroyUser($id)
    {
        try {
            $user = \App\Models\User::findOrFail($id);
            // Delete all comments by this user
            \App\Models\Comment::where('user_id', $id)->delete();
            // Delete the user
            $user->delete();
            
            // For AJAX requests, return JSON response
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User and all their comments deleted successfully'
                ]);
            }
            
            // For regular requests, redirect
            return redirect()->route('admin.comments.index')
                ->with('success', 'User and all their comments deleted successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting user: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.comments.index')
                ->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
}