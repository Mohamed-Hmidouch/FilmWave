<?php
namespace App\Requests\Admin;

use App\Requests\BaseRequestForm;
use Illuminate\Http\Request;

class TagValidator extends BaseRequestForm
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:50|unique:tags,name'
        ];

        // Si on est en mode édition, exclure le tag actuel de la règle d'unicité
        if ($this->request->isMethod('put') || $this->request->isMethod('patch')) {
            $tagId = $this->request->route('tag');
            $rules['name'] = 'required|string|max:50|unique:tags,name,' . $tagId;
        }

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorized(): bool
    {
        return true;
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du tag est obligatoire.',
            'name.string' => 'Le nom du tag doit être une chaîne de caractères.',
            'name.max' => 'Le nom du tag ne doit pas dépasser 50 caractères.',
            'name.unique' => 'Ce nom de tag existe déjà.'
        ];
    }
    
    /**
     * Get tag data from request
     *
     * @return array
     */
    public function getTagData(): array
    {
        $this->validate();
        
        return [
            'name' => $this->request->input('name')
        ];
    }
} 