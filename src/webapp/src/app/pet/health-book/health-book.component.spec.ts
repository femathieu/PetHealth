import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { HealthBookComponent } from './health-book.component';

describe('HealthBookComponent', () => {
  let component: HealthBookComponent;
  let fixture: ComponentFixture<HealthBookComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ HealthBookComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(HealthBookComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
