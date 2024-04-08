<?php

use App\Exceptions\ValidationFailedException;
use ResponseHelperTrait;

try {
} catch (ValidationFailedException $e) {
    $errors = $e->getErrors();
    return $this->returnWrong('Validation error during import', $errors);
} catch (\Exception $e) {
    $errors = $e->getMessage();
    return $this->returnWrong('Validation error during import', $errors, 500);
}
