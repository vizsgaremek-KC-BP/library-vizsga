import { Inject, Injectable } from '@angular/core';
import { HttpService } from './http.service';
import { User } from '../interfaces/User';

@Injectable({
  providedIn: 'root'
})

export class AuthenticationService {
  initfelhasznalo: User = { 
    message: "",
    token: "",
    user: {
      id: "",
      name: "",
      email: "",
      edu_id: "",
      role: "",
      created_at: "",
      updated_at: ""
    }
  };


  private isAuthenticated = false;
  private felhasznalo: User = {
    message: "",
    token: "",
    user: {
      id: "",
      name: "",
      email: "",
      edu_id: "",
      role: "",
      created_at: "",
      updated_at: ""
    }
  };
  http: HttpService;
  

  constructor(http: HttpService) {
    this.http = http;
    this.felhasznalo = this.initfelhasznalo;
    this.felhasznalo.token = localStorage.getItem('token') || '';
    this.felhasznalo.user.role = localStorage.getItem('role') || '';
    if(localStorage.getItem('isLoggedIn') === 'true'){
      this.isAuthenticated = true;
    }else{
      this.isAuthenticated = false;
    }
  }

  public login(email: string, passWord: string): Promise<string> {
    return new Promise<string>((resolve, reject) => this.http.login( email, passWord ).subscribe((response: User) => {
      this.felhasznalo = response;
      localStorage.setItem('userName', this.felhasznalo.user.name);
      localStorage.setItem('token', this.felhasznalo.token);
      localStorage.setItem('role', this.felhasznalo.user.role);
      localStorage.setItem('isLoggedIn', 'true');
      resolve(response.message);
    },
    error => {
      console.log(error);
      reject(error.message);
    }));
  }

  public register(userName: string, email: string, studentId: string, passWord: string,  passWordConfirm: string): void {
    this.http.registration(userName, email, studentId, passWord, passWordConfirm ).subscribe(
      response => {
        alert(response.message);
      },
      error => {
        if (error.error && error.error.errors) {
          const errors = error.error.errors;
          let errorMessages = [];
      
          for (const field in errors) {
            if (errors[field]) {
              errorMessages.push(`${field}: ${errors[field].join(', ')}`);
            }
          }
          alert(errorMessages.join('\n'));
        } else {
          alert("Ismeretlen hiba történt!");
        }
      });
  }

  public logout(): void {
    this.isAuthenticated = false;
    this.felhasznalo = this.initfelhasznalo;
    localStorage.clear();
    localStorage.setItem('isLoggedIn', 'false');
  }

  public isLoggedIn(): boolean {
      this.felhasznalo.token = localStorage.getItem('token') || '';
      this.felhasznalo.user.role = localStorage.getItem('role') || '';
    if(localStorage.getItem('isLoggedIn') === 'true'){
      this.isAuthenticated = true;
      return this.isAuthenticated;
    }else{
      this.isAuthenticated = false;
      return this.isAuthenticated;
    }
  }

  public isAdmin(): boolean {
    return this.felhasznalo?.user.role === 'admin';
  }
  public isStudent(): boolean {
    return this.felhasznalo?.user.role === 'student';
  }

}