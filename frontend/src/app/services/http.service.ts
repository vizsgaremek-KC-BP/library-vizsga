import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class HttpService {
  private apiUrlBooks = 'Api helye';
  private apiUrlStudents = 'Api helye';

  constructor(private http: HttpClient) {}

  getBook(): Observable<any> {
    return this.http.get<any>(this.apiUrlBooks);
  }

  addBook(books: any): Observable<any> {
    return this.http.post<any>(this.apiUrlBooks, books);
  }

  updateBook(id: number, books: any): Observable<any> {
    return this.http.put<any>(`Api helye${id}.json`, books);
  }

  deleteBook(id: number): Observable<any> {
    return this.http.delete<any>(`Api helye${id}.json`);
  }


  getStudent(): Observable<any> {
    return this.http.get<any>(this.apiUrlStudents);
  }

  addStudent(students: any): Observable<any> {
    return this.http.post<any>(this.apiUrlStudents, students);
  }

  updateStudent(id: number, students: any): Observable<any> {
    return this.http.put<any>(`Api helye${id}.json`, students);
  }

  deleteStudent(id: number): Observable<any> {
    return this.http.delete<any>(`Api helye${id}.json`);
  }
}
