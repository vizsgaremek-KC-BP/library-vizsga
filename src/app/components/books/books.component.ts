import { Component, Input, OnInit } from '@angular/core';
import { HttpService } from '../../services/http.service';
import { ConfigService } from '../../services/config.service';
import { TranslateService } from '@ngx-translate/core';

@Component({
  selector: 'app-books',
  templateUrl: './books.component.html',
  styleUrl: './books.component.css'
})
export class BooksComponent implements OnInit {
  setEditBook() {
    this.editBooks = !this.editBooks;
  }
    @Input() books!: any;
    editBooks: boolean = false;
    titles: any = {};
  
    modifiedBook: any = {
      id: 0,
      whId: '',
      title: '',
      author: '',
      price: 0,
      quantity: 0
    };
  
    constructor(
      private db: HttpService,
      private config: ConfigService,
      private translate: TranslateService
    ) {
      this.translate.setDefaultLang('en');
      this.translate.use('en');
    }
    switchLanguage(lang: string) {
      this.translate.use(lang);
    }
  
    ngOnInit(): void {}
  
    createBook(): void {
      if (this.books.title && this.books.price > 0) {
        this.db.addBook(this.books).subscribe(
          data => {
            console.log('Könyv hozzáadva', data);
          },
          error => {
            console.error('Hiba történt a könyv hozzáadása közben', error);
          }
        );
      } else {
        console.log('Kérlek, töltsd ki az összes mezőt.');
      }
    }
  
    modifyBook(): void{
      this.db.updateBook(this.modifiedBook.id, this.modifiedBook).subscribe(
        data => {
          console.log('Könyv frissítve', data);
        },
        error => {
          console.error('Hiba történt a könyv frissítésekor', error);
        }
      );
    }
  
    deleteBook(): void{
      this.db.deleteBook(this.books.id).subscribe(
        data => {
          console.log('Könyv törölve', data);
        },
        error => {
          console.error('Hiba történt a könyv törlésekor', error);
        }
      );
    }
    
    resetNewBook(): void {
      this.modifiedBook = { id: this.books.id, whId: '', title: '', author: '',  price: 0, quantity: 0 };
    }
}