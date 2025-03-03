import { Component } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-registration',
  templateUrl: './registration.component.html',
  styleUrl: './registration.component.css'
})
export class RegistrationComponent {
  userName = "";
  passWord = "";
  studentId = "";
  passWordConfirm = "";
  email = "";
  public register() {
      this.auth.register(this.userName, this.email, this.studentId, this.passWord, this.passWordConfirm);
      
      this.router.navigate(['login']);
  }
  constructor(public auth:AuthenticationService, private router: Router) { }
}