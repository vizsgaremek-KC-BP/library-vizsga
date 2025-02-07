import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  private isAuthenticated = false;
  public login(userName: string, passWord: string): boolean {
    if (userName === 'admin' && passWord === 'admin') {
      this.isAuthenticated = true;
      localStorage.setItem('userName', userName)
      return true;
    }
    this.isAuthenticated = false;
    return false;
  }

  public logout(): void {
    this.isAuthenticated = false;
  }

  public isLoggedIn(): boolean {
    return this.isAuthenticated;
  }

  public register(userName: string, passWord: string, emailAddress: string): boolean {
    return true;
  }

  constructor() { }
}
