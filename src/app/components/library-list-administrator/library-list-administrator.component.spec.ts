import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LibraryListAdministratorComponent } from './library-list-administrator.component';

describe('LibraryListAdministratorComponent', () => {
  let component: LibraryListAdministratorComponent;
  let fixture: ComponentFixture<LibraryListAdministratorComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [LibraryListAdministratorComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(LibraryListAdministratorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
