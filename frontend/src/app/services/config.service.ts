import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ConfigService {

  private content = new Subject()
  private langSign="hu"

  constructor(private http:HttpClient) { 
    this.loadContent()
  }

  changeLanguage(langSign:any){
    this.langSign=langSign
    this.loadContent()
  }

  loadContent(){
    this.http.get("/assets/"+this.langSign+".json").subscribe(
      (res)=>
        {
          console.log(res)
          this.content.next(res)
        }
      )
  }

  getContent():Subject<any>{
    return this.content
  }

}