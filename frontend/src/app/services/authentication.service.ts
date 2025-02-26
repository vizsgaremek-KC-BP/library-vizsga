import { Injectable } from '@angular/core';

class User {
  private userName: string;
  private passWord: string;
  private csoport: string = '';
  constructor(name: string, pass: string) {
    this.userName = name;
    this.passWord = pass;
   }

   public getUserName(): string {
    return this.userName;
   }

   public getPassWord(): string {
    return this.passWord;
   }

   public getCsoport(): string {
    return this.csoport;
   }

   public setCsoport(csoport: string) {
    this.csoport = csoport;
   }
}

@Injectable({
  providedIn: 'root'
})

export class AuthenticationService {
  private isAuthenticated = false;
  private felhasznalo: User;

  public login(userName: string, passWord: string): boolean {
    this.felhasznalo = new User(userName, passWord);
    if ((userName === 'Könyvtáros' && passWord === 'asd')|| (userName === 'Diák' && passWord === 'asd')) {
      this.felhasznalo.setCsoport(this.getCsoport(userName));
      this.isAuthenticated = true;
      localStorage.setItem('userName', userName)
      return true;
    }
    this.isAuthenticated = false;
    return false;
  }

  private getCsoport(userName: string): string {
    if(userName == 'Könyvtáros') {
      return "Könyvtáros";
    }else{
      return "Diák";
    }
  }

  public logout(): void {
    this.isAuthenticated = false;
  }

  public isLoggedIn(): boolean {
    return this.isAuthenticated;
  }

  public isKonyvtaros(): boolean {
    return this.felhasznalo.getCsoport() === 'Könyvtáros';
  }
  public isDiak(): boolean {
    return this.felhasznalo.getCsoport() === 'Diák';
  }

  public register(userName: string, passWord: string, emailAddress: string): boolean {
    return true;
  }

  constructor() { 
    this.felhasznalo = new User('', '');
  }
}