<?php
namespace Framework\Validator;

class ValidationError
{

    private $key;
    private $rule;

    private $message = [
        'required' => 'Le champs %s est requis',
        'empty' => 'Le champs %s ne peux être vide',
        'slug' => 'Le champs %s n\'est pas valide',
        'minLength' => 'Le champs %s doit contenir plus de %d caractères',
        'maxLength' => 'Le champs %s doit co$dateTime = ntenir moins de %d caractères',
        'maxLength' => 'Le champs %s doit contenir entre %d et %d caractères',
        'datetime' => 'Le champs %s doit être une date valide (%s)',
    ];
    /**
     * @var array
     */
    private $attributes;

    /**
     * ValidationError constructor.
     * @param string $key
     * @param string $rule
     * @param array $attributes
     */
    public function __construct(string $key, string $rule, array $attributes = [])
    {
        $this->key = $key;
        $this->rule = $rule;
        $this->attributes = $attributes;
    }

    public function __toString()
    {
        $params  = array_merge([$this->message[$this->rule],$this->key], $this->attributes);
        return (string)call_user_func_array('sprintf', $params);
    }
}
