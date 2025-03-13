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
  
    id: number = 0;
    inventory_number_base: string = '';
    title: string = '';
    author: string = '';
    price: number = 0;
    copies: number = 0;
    selectedBook: any = null;
    
    bookArray: any[] = [];

  setEditBook() {
    this.editBooks = !this.editBooks;
  }
    @Input() books!: any;
    editBooks: boolean = false;
    titles: any = {};

    modifiedBook: any = {
        id: 0,
        inventory_number_base: '',
        title: '',
        author: '',
        price: 0,
        copies: 0,
        created_at: '',
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
      // this.translate.setDefaultLang('en');
      // this.translate.use('en');
    }
    // switchLanguage(lang: string) {
    //   this.translate.use(lang);
    // }
  
    ngOnInit(): void {}
  
    createBook(): void {
        this.db.addBook(this.inventory_number_base, this.title, this.author, this.price, this.copies).subscribe(
          data => {
            console.log('Könyv hozzáadva', data);
            window.location.reload();
          },
          error => {
            console.error('Hiba történt a könyv hozzáadása közben', error);
          }
        );
        console.log('Kérlek, töltsd ki az összes mezőt.');
    }

    setSelectedBook(book: any) {
      this.selectedBook = { ...book }; 
    }
  
    modifyBook(id: string, inventory_number_base: string, title: string, author: string, price: number, copies: number): void{
      this.db.updateBook(id, inventory_number_base, title, author, price, copies).subscribe(
        data => {
          console.log('Könyv frissítve', data);
          window.location.reload();
        },
        error => {
          console.error('Hiba történt a könyv frissítésekor', error);
        }
      );
    }
  
    deleteBook(id:string): void{
      this.db.deleteBook(id).subscribe(
        data => {
          console.log('Könyv törölve', data);
          window.location.reload();
        },
        error => {
          console.error('Hiba történt a könyv törlésekor', error);
        }
      );
    }
}