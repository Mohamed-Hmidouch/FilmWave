<?php

namespace App\Requests\Comment;

use App\Requests\BaseRequestForm;
use Illuminate\Http\Request;

class CommentValidator extends BaseRequestForm
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * Constructeur du validateur
     * 
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function rules(): array
    {
        return [
            'episode_id' => 'required|integer|exists:episodes,id',
            'series_id' => 'required|integer|exists:series,id',
            'body' => 'required|string|min:2|max:1000',
        ];
    }


    public function messages(): array
    {
        return [
            'episode_id.required' => 'L\'identifiant de l\'épisode est requis',
            'episode_id.exists' => 'Cet épisode n\'existe pas',
            'series_id.required' => 'L\'identifiant de la série est requis',
            'series_id.exists' => 'Cette série n\'existe pas',
            'body.required' => 'Le contenu du commentaire est requis',
            'body.min' => 'Le commentaire doit contenir au moins :min caractères',
            'body.max' => 'Le commentaire ne peut pas dépasser :max caractères',
        ];
    }



}
