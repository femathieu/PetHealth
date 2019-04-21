import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { MatStepper } from '@angular/material';

@Component({
  selector: 'pet-crud',
  templateUrl: './crud.component.html',
  styleUrls: ['./crud.component.scss'],
  
})


export class CrudComponent implements OnInit {

  petFormStep1 : FormGroup = this.fb.group({
    petFormStep1 : this.fb.group({
      type:  [
        '', 
        [Validators.required]
      ]
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
  
  submitStep1(stepper: MatStepper): void {
    console.log(this.petFormStep1.status);
    if(this.petFormStep1.status == 'VALID'){
      stepper.next();
    }else{
      console.warn('pick something');
    }
  }
  
}
