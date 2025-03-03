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
  bookArray: any[] = [];
  setEditBook() {
    this.editBooks = !this.editBooks;
  }
    @Input() books!: any;
    editBooks: boolean = false;
    titles: any = {};
  
    modifiedBook: any = {
      book_id: 0,
      book_type: {
        id: 0,
        title: '',
        author: '',
        price: 0,
        copies: 0,
      },
      created_at: '',
      id: 0,
      inventory_number: '',
      updated_at: '',
    };
  
    constructor(
      private db: HttpService,
      private config: ConfigService,
      private translate: TranslateService
    ) {
      db.getBook().subscribe(data => {
        this.bookArray = data;
        console.log(this.bookArray);
      });



      this.translate.setDefaultLang('en');
      this.translate.use('en');
    }
    switchLanguage(lang: string) {
      this.translate.use(lang);
    }
  
    ngOnInit(): void {}
  
    createBook(): void {
      if (this.books.title && this.books.price > 0) {
        this.db.addBook().subscribe(
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
      this.db.updateBook().subscribe(
        data => {
          console.log('Könyv frissítve', data);
        },
        error => {
          console.error('Hiba történt a könyv frissítésekor', error);
        }
      );
    }
  
    deleteBook(): void{
      this.db.deleteBook().subscribe(
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