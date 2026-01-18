<?php

declare(strict_types=1);

namespace SellNow\Core\Validation;

use SellNow\Core\Validation\Rules\{
    RequiredRule,
    StringRule,
    EmailRule,
    MaxRule,
    ConfirmedRule,
    MinRule,
    FileRule,
    MimesRule,
    NullableRule,
    NumericRule
};

class Validator
{
    protected array $rulesMap = [
        'required' => RequiredRule::class,
        'string'   => StringRule::class,
        'email'    => EmailRule::class,
        'max'      => MaxRule::class,
        'confirmed' => ConfirmedRule::class,
        'min'      => MinRule::class,
        'file'     => FileRule::class,
        'mimes'    => MimesRule::class,
        'nullable' => NullableRule::class,
        'numeric' => NumericRule::class,
    ];

    protected array $errors = [];

    /**
     * Validate the given data against the specified rules.
     */
    public function validate(array $data, array $rules): ValidationResult
    {
        foreach ($rules as $field => $ruleString) {
            $value = $data[$field] ?? null;
            $this->applyRules($field, $value, $ruleString, $data);
        }

        return new ValidationResult($this->errors);
    }

    /**
     * Apply validation rules to a specific field.
     */
    protected function applyRules(string $field, mixed $value, string $ruleString, array $data): void
    {
        $rules = explode('|', $ruleString);

        if (in_array('nullable', $rules, true) && $this->isEmptyValue($value)) {
            return;
        }

        foreach ($rules as $rule) {
            [$name, $params] = $this->parseRule($rule);

            $ruleClass = $this->rulesMap[$name] ?? null;

            if (!$ruleClass) {
                throw new \Exception("Validation rule '{$name}' not found");
            }

            $message = (new $ruleClass())->validate($field, $value, $params, $data);

            if ($message) {
                $this->errors[$field][] = $message;
            }
        }
    }

    /**
     * Check if a value is empty.
     */
    protected function isEmptyValue(mixed $value): bool
    {
        if ($value === null) {
            return true;
        }

        if (is_array($value) && isset($value['error'])) {
            return $value['error'] !== UPLOAD_ERR_OK;
        }

        if (is_array($value)) {
            return empty($value);
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        return false;
    }

    /**
     * Parse a rule string into its name and parameters.
     */
    protected function parseRule(string $rule): array
    {
        $parts = explode(':', $rule);
        $name = $parts[0];
        $params = isset($parts[1]) ? explode(',', $parts[1]) : [];

        return [$name, $params];
    }
}
