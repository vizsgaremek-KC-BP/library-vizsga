import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class HttpService {
  private apiUrl = 'http://127.0.0.1:8000/api';

  constructor(private http: HttpClient) {}

  
  login( email: string, password: string ): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/auth/login`, { email, password });
  }

  registration(name: string, email: string, edu_id: string, password: string, password_confirmation: string): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/auth/register`, { name, email, edu_id, password, password_confirmation  });
  }


  getBook(): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    return this.http.get<any>(`${this.apiUrl}/book-types`, { headers });
  }

  getStudentBook(): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    return this.http.get<any>(`${this.apiUrl}/books`, { headers });
  }//ez lesz a getelos fuggveny meg nincs kesz
  
  addBook(inventory_number_base: string, title: string, author: string, price: number, copies: number): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
    const body = { inventory_number_base, title, author, price, copies };

    return this.http.post<any>(`${this.apiUrl}/book-types`, body, { headers });
  }
  
  updateBook(id: string, inventory_number_base: string, title: string, author: string, price: number, copies: number): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
    const body = { inventory_number_base, title, author, price, copies };
  
    return this.http.put<any>(`${this.apiUrl}/book-types/${id}`, body, { headers });
  }
  deleteBook(id: string): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    return this.http.delete<any>(`${this.apiUrl}/book-types/${id}`, { headers });
  }
  
  returnBook(loan_id: string): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    return this.http.post<any>(`${this.apiUrl}/books/return/${loan_id}`, {}, { headers });
  }

  getLoans(): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    return this.http.get<any>(`${this.apiUrl}/loans`, { headers });
  }
  getMyLoans(): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    return this.http.get<any>(`${this.apiUrl}/myLoans`, { headers });
  }

  addLoan(edu_id: string, inventory_number: string): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
    const body = { user_edu_id:edu_id, inventory_number };

    return this.http.post<any>(`${this.apiUrl}/books/borrow`, body, { headers });
  }

  approveLoan(loan:string): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    return this.http.post<any>(`${this.apiUrl}/loans/approve/${loan}`, {}, { headers });
  }

  forceApproveLoan(loan:string): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    return this.http.post<any>(`${this.apiUrl}/loans/${loan}/force`, {}, { headers });
  }

  rejectLoan(loan: string): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    return this.http.post<any>(`${this.apiUrl}/loans/reject/${loan}`, {}, { headers });
  }


  
  getStudent(): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    return this.http.get<any>(`${this.apiUrl}/users`, { headers });
  }
  
  addStudent( edu_id: string, email: string, name: string ): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
    const body = { name, email, edu_id };

    return this.http.post<any>(`${this.apiUrl}/users`, body, { headers });
  }
  
  updateStudent(id: string, email: string, name: string, role: string): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
    const body = { email, name, role };
  
    return this.http.put<any>(`${this.apiUrl}/users/${id}`, body, { headers });
  }
  
  deleteStudent(id: string): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    return this.http.delete<any>(`${this.apiUrl}/users/${id}`, { headers });
  }
}
