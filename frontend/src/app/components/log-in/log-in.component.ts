import { Component, Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { AuthenticationService } from '../../services/authentication.service';

@Component({
  selector: 'app-log-in',
  templateUrl: './log-in.component.html',
  styleUrl: './log-in.component.css'
})
@Injectable({
  providedIn:'root'
})
export class LogInComponent {
  userName = "";
  passWord = "";
  public login() {
      if (this.auth.login(this.userName, this.passWord)){

        this.router.navigate(['library']);
      }else{
        alert("Login Failed");
      }
    }
  constructor(public auth:AuthenticationService, private router: Router) { }

  
}
