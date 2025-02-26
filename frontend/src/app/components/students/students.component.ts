import { Component, Input, OnInit } from '@angular/core';
import { HttpService } from '../../services/http.service';
import { ConfigService } from '../../services/config.service';
import { TranslateService } from '@ngx-translate/core';

@Component({
  selector: 'app-students',
  templateUrl: './students.component.html',
  styleUrl: './students.component.css'
})
export class StudentsComponent implements OnInit {
  setEditStudent() {
    this.editStudents = !this.editStudents;
  }
    @Input() students!: any;
    editStudents: boolean = false;
    titles: any = {};
  
    modifiedStudent: any = {
      id: 0,
      name: '',
      userName: '',
      emailAddress: '',
      passWord: '',
      sId: 0,
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
  
    ngOnInit(): void {
        
      }
    
  
    createStudent(): void {
      if (this.students.name && this.students.sId > 0) {
        this.db.addStudent(this.students).subscribe(
          data => {
            console.log('Diák hozzáadva', data);
          },
          error => {
            console.error('Hiba történt a diák hozzáadása közben', error);
          }
        );
      } else {
        console.log('Kérlek, töltsd ki az összes mezőt.');
      }
    }
  
    modifyStudent(): void{
      this.db.updateStudent(this.modifiedStudent.id, this.modifiedStudent).subscribe(
        data => {
          console.log('Diák frissítve', data);
        },
        error => {
          console.error('Hiba történt a diák frissítésekor', error);
        }
      );
    }
  
    deleteStudent(): void{
      this.db.deleteStudent(this.students.id).subscribe(
        data => {
          console.log('Diák törölve', data);
        },
        error => {
          console.error('Hiba történt a diák törlésekor', error);
        }
      );
    }
    
    resetNewStudent(): void {
      this.modifiedStudent = { id: this.students.id, name: '', userName: '', emailAddress: '', passWord: '', sId: 0 };
    }
}
