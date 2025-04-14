<?php
namespace App\Requests\Admin;

use App\Requests\BaseRequestForm;
use Illuminate\Http\Request;

class CategoryValidator extends BaseRequestForm
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
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'nullable|string|max:255'
        ];

        // Si on est en mode édition, exclure la catégorie actuelle de la règle d'unicité
        if ($this->request->isMethod('put') || $this->request->isMethod('patch')) {
            $categoryId = $this->request->route('category');
            $rules['name'] = 'required|string|max:50|unique:categories,name,' . $categoryId;
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
            'name.required' => 'Le nom de la catégorie est obligatoire.',
            'name.string' => 'Le nom de la catégorie doit être une chaîne de caractères.',
            'name.max' => 'Le nom de la catégorie ne doit pas dépasser 50 caractères.',
            'name.unique' => 'Ce nom de catégorie existe déjà.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 255 caractères.'
        ];
    }
    
    /**
     * Get category data from request
     *
     * @return array
     */
    public function getCategoryData(): array
    {
        return [
            'name' => $this->request->input('name'),
            'description' => $this->request->input('description')
        ];
    }
} 