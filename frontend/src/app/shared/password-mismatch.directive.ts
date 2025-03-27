import { AbstractControl, ValidationErrors, ValidatorFn } from "@angular/forms";

export const passwordMismatchValidator: ValidatorFn = (control: AbstractControl): ValidationErrors | null => {
    const passwordControl = control.get('passwordControl');
    const passwordConfirmControl = control.get('passwordConfirmControl');

    return passwordControl && passwordConfirmControl && passwordControl.value !== passwordConfirmControl.value ? {
        passwordMismatch: true
    } : null;
}