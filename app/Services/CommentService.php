<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\User;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentService
{
    /**
     * Create a new comment
     *
     * @param array $data
     * @return Comment
     */
    public function create(array $data): Comment
    {
        Log::info('Creating comment', ['content_id' => $data['content_id'], 'user_id' => Auth::id()]);
        
        try {
            $comment = Comment::create([
                'content_id' => $data['content_id'],
                'user_id' => Auth::id(),
                'body' => $data['body'],
            ]);
            
            Log::info('Comment created successfully', ['comment_id' => $comment->id]);
            
            return $comment;
        } catch (\Exception $e) {
            Log::error('Error creating comment in service', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);
            
            throw $e;
        }
    }

    /**
     * Get comments for a specific content
     *
     * @param int $contentId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getContentComments(int $contentId, int $perPage = 10): LengthAwarePaginator
    {
        Log::info('Getting comments for content', ['content_id' => $contentId, 'per_page' => $perPage]);
        
        return Comment::where('content_id', $contentId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get all comments with pagination for admin view
     *
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllComments(int $perPage = 10): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Comment::with(['user', 'content'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Delete a comment
     *
     * @param int $commentId
     * @param int $userId
     * @param bool $isAdmin Whether the request is from an admin (bypasses user check)
     * @return bool
     */
    public function delete(int $commentId, int $userId, bool $isAdmin = false): bool
    {
        Log::info('Deleting comment', ['comment_id' => $commentId, 'user_id' => $userId, 'is_admin' => $isAdmin]);
        
        $comment = Comment::find($commentId);
        
        if (!$comment) {
            Log::warning('Comment not found for deletion', ['comment_id' => $commentId]);
            return false;
        }
        
        if (!$isAdmin && $comment->user_id !== $userId) {
            Log::warning('Unauthorized comment deletion attempt', [
                'comment_id' => $commentId, 
                'comment_user_id' => $comment->user_id,
                'request_user_id' => $userId
            ]);
            return false;
        }
        
        $result = $comment->delete();
        Log::info('Comment deleted', ['comment_id' => $commentId, 'success' => $result]);
        
        return $result;
    }

    /**
     * Update a comment
     *
     * @param int $commentId
     * @param string $body
     * @param int $userId
     * @return Comment|bool
     */
    public function update(int $commentId, string $body, int $userId): Comment|bool
    {
        Log::info('Updating comment', ['comment_id' => $commentId, 'user_id' => $userId]);
        
        $comment = Comment::find($commentId);
        
        if (!$comment) {
            Log::warning('Comment not found for update', ['comment_id' => $commentId]);
            return false;
        }
        
        if ($comment->user_id !== $userId) {
            Log::warning('Unauthorized comment update attempt', [
                'comment_id' => $commentId, 
                'comment_user_id' => $comment->user_id,
                'request_user_id' => $userId
            ]);
            return false;
        }
        
        $comment->body = $body;
        $result = $comment->save();
        
        Log::info('Comment updated', ['comment_id' => $commentId, 'success' => $result]);
        
        return $comment;
    }
}