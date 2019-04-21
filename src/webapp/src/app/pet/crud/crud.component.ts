import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators, FormControl } from '@angular/forms';
import { STEPPER_GLOBAL_OPTIONS } from '@angular/cdk/stepper';

import { PetService } from '../../services/pet/pet.service';
import { Pet } from '../../models/pet';
import { HttpResponse } from '@angular/common/http';

@Component({
  selector: 'pet-crud',
  templateUrl: './crud.component.html',
  styleUrls: ['./crud.component.scss'],
  providers: [
    {provide: STEPPER_GLOBAL_OPTIONS, useValue: {showError: true}},
  ]
})


export class CrudComponent implements OnInit {
  
  // date = new FormControl(moment([2017, 0, 1]));

  firstFormGroup: FormGroup;
  secondFormGroup: FormGroup;
  pet: Pet = new Pet();

  constructor(
    private _formBuilder: FormBuilder,
    public petService: PetService
    ) {}

  ngOnInit() {
    this.firstFormGroup = this._formBuilder.group({
      type: new FormControl(
        this.pet.typeId, 
        Validators.required
      )
    });
    this.secondFormGroup = this._formBuilder.group({
      name: [this.pet.name, Validators.compose([
        Validators.required,
        Validators.minLength(3),
        Validators.maxLength(15),
      ])],
      birthdate: new FormControl(
        this.pet.birthdate,
        Validators.required
      ) 
    });
  }
  
  onSubmitFormFirst(): void {
    this.pet.typeId = this.firstFormGroup.value.type;
  }

  onSubmitFormSecond(): void {
    this.pet.name = this.secondFormGroup.value.name;
    this.pet.birthdate = this.secondFormGroup.value.birthdate.getTime()/1000;
    this.petService.add(this.pet).subscribe((res) =>{
      if(res instanceof HttpResponse){
        if(res.status == 200){
          console.log('succes')
        }
      }
    });
    console.log(this.pet.birthdate, this.pet.name);
    console.log(this.secondFormGroup.value, this.secondFormGroup.status);
    console.log(this.pet);
    
  }
}
