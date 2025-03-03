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
  email = "";
  passWord = "";
  public login() {
    this.auth.login(this.email, this.passWord).then(message => {
      if(localStorage.getItem('role') == 'student'){
        this.router.navigate(['libraryUser']);
      }else if(localStorage.getItem('role') == 'admin'){
        this.router.navigate(['libraryAdmin']);
      }
    }).catch(error => alert(error));
  }
  constructor(public auth:AuthenticationService, private router: Router) { }

  
}
