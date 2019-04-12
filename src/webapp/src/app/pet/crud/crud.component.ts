
import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';

@Component({
  selector: 'pet-crud',
  templateUrl: './crud.component.html',
  styleUrls: ['./crud.component.scss'],
  
})


export class CrudComponent implements OnInit {

  petFormStep1 : FormGroup = this.fb.group({
    petFormStep1 : this.fb.group({
      type:  ['']
    })
  });
  petFormStep2 : FormGroup = this.fb.group({
    name:  ['', [
      Validators.required,
      Validators.minLength(4), 
      Validators.maxLength(10)
    ]]
  });
  petFormStep3 : FormGroup = this.fb.group({
    age: ['', Validators.required]
  });

  constructor(private fb: FormBuilder) { }
  
  ngOnInit() {
  }
  
  onSubmit(): void {
    console.warn(this.petFormStep1.value, this.petFormStep1.status);
  }
  
}
