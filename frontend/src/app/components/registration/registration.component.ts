import { Component } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';
import { Router } from '@angular/router';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { passwordMismatchValidator } from '../../shared/password-mismatch.directive';

@Component({
  selector: 'app-registration',
  templateUrl: './registration.component.html',
  styleUrl: './registration.component.css'
})
export class RegistrationComponent {
  registerForm = new FormGroup({
    usernameControl: new FormControl('', [Validators.required]),
    emailControl: new FormControl('', [
      Validators.required,
      Validators.pattern(/[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/)
    ]),
    studentIdControl: new FormControl('', [
      Validators.required,
      Validators.pattern(/^7\d{10}$/)
    ]),
    passwordControl: new FormControl('', [
      Validators.required,
      Validators.pattern(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/)
    ]),
    passwordConfirmControl: new FormControl('', [
      Validators.required,
      Validators.pattern(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/)])
    
  },{
    validators: passwordMismatchValidator
  });
  get usernameControl(){ return this.registerForm.controls['usernameControl']; }
  get emailControl(){ return this.registerForm.controls['emailControl']; }
  get studentIdControl(){ return this.registerForm.controls['studentIdControl']; }
  get passwordControl(){ return this.registerForm.controls['passwordControl']; }
  get passwordConfirmControl(){ return this.registerForm.controls['passwordConfirmControl']; }

  username = "";
  email = "";
  studentId = "";
  password = "";
  passwordConfirm = "";
  public register() {
      this.auth.register(this.username, this.email, this.studentId, this.password, this.passwordConfirm);
      
      this.router.navigate(['login']);
  }
  constructor(public auth:AuthenticationService, private router: Router) { }
}