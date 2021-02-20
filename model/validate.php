<?php

/*
 * model/
 * contains validation functions for food app
 */

/** validFood() returns true if food is not empty and contains only letters */
function validName($name)
{
    return !empty($name);
}
/** validMeal() returns true if the selected meal is in the list of valid options */


function validOptions($selectedOptions) {
    $validOptions = getOptions();
    foreach ($selectedOptions as $selected) {
        if (!in_array($selected,$validOptions)){
            return false;
        }
    }
    return true;
}