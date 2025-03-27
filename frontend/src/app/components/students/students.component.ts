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
    id: number = 0;
    name: string = '';
    email: string = '';
    edu_id: string = '';
    password: string = '';
    role: string = '';
    selectedStudent: any = null;

    studentArray: any[] = [];
    filteredStudents: any[] = [];
    searchText: string = '';

  setEditStudent() {
    this.editStudents = !this.editStudents;
  }
    @Input() student!: any;
    editStudents: boolean = false;
    titles: any = {};
  
    modifiedStudent: any = {
      id: 0,
      name: '',
      email: '',
      email_verified_at: '',
      password: '',
      edu_id: '',
      role: '',
      status: '',
      remember_token: '',
      created_at: '',
      updated_at: '',
    };
  
    constructor(
      private db: HttpService,
      private config: ConfigService,
      private translate: TranslateService
    ) {
      db.getStudent().subscribe(data => {
        this.studentArray = data;
        this.filteredStudents = [];
        // console.log(this.studentArray);
      });
    }
    switchLanguage(lang: string) {
      this.translate.use(lang);
    }
  
    ngOnInit(): void {
        
      }
    
      filterStudents() {
        if (!this.searchText) {
          this.filteredStudents = [];
          return;
        }
        const searchLower = this.searchText.toLowerCase();
    
        this.filteredStudents = this.studentArray.filter(student =>
          Object.values(student).some(val =>
            val?.toString().toLowerCase().includes(searchLower)
          )
        );
      }
    
  
    createStudent(): void {
        this.db.addStudent(this.name, this.edu_id).subscribe(
          data => {
            console.log('Diák hozzáadva', data);
            window.location.reload();
          },
          error => {
            console.error('Hiba történt a diák hozzáadása közben', error);
          }
        );
        console.log('Kérlek, töltsd ki az összes mezőt.');
    }

    setSelectedStudent(student: any) {
      this.selectedStudent = { ...student }; 
    }

    modifyStudent(id: string, name: string): void {
      this.db.updateStudent(id, name).subscribe(
        data => {
          console.log('Diák frissítve', data);
          window.location.reload();
        },
        error => {
          console.error('Hiba történt a diák frissítésekor', error);
        }
      );
    }
    
  
    statusStudent(id: string, currentStatus: string): void {
      const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
  
      this.db.statusSwitchStudent(id, newStatus).subscribe(
          data => {
              console.log('Diák státusza frissítve', data);
              this.studentArray = this.studentArray.map(student =>
                  student.id === id ? { ...student, status: newStatus } : student
              );
              window.location.reload();
          },
          error => {
              console.error('Hiba történt a státusz frissítésekor', error);
          }
      );
    }
}
