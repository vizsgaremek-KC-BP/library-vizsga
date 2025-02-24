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
  public register() {
      if (this.auth.register(this.userName, this.passWord, this.studentId)) {

        this.router.navigate(['home']);
      }else{
        alert("Register Failed");
      }
    }
  constructor(public auth:AuthenticationService, private router: Router) { }

}
