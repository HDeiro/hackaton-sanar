import { Component, OnInit } from '@angular/core';
import { FormErrorMatcher } from 'src/app/utilities/form-error-matcher.util';
import { FormControl, Validators } from '@angular/forms';
import { PrescriptionService } from 'src/app/services/api/prescription/prescription.service';
import { DateAdapter, MatSnackBar } from '@angular/material';
import { ObjectUtils } from 'src/app/utilities/object-utils.util';
import { AuthService } from 'src/app/services/api/auth/auth.service';
import { Directionality } from '@angular/cdk/bidi';

@Component({
  selector: 'app-prescription',
  templateUrl: './prescription.component.html',
  styleUrls: ['./prescription.component.scss'],
  providers: [

  ]
})
export class PrescriptionComponent implements OnInit {
  
  options: Array<any> = [];
  prescription = {prescription_items: [{}]};
  passwordIsHidden = true;
  matcher = new FormErrorMatcher();
  formControl = new FormControl('', [
    Validators.required,
    Validators.email,
  ]);
  periodicity_types = [
    { label: 'Minutos', value: 'i' },
    { label: 'Horas', value: 'h' },
    { label: 'Dias', value: 'd' },
    { label: 'Semanas', value: 'w' },
    { label: 'Meses', value: 'm' },
  ];

  constructor(
    private prescriptionService: PrescriptionService,
    private authService: AuthService,
    private _snackBar: MatSnackBar
  ) { }

  ngOnInit() {
    this.prescription = {prescription_items: [{}]};
    
    this.prescriptionService.getPatients().subscribe(response => {
      this.options = response.data;
    });
  }

  extractDate(dateString: string) {
    let date = new Date(dateString);
    let month = (date.getMonth() + 1);
    let hours = date.getHours();
    let minutes = date.getMinutes();
    return date.getFullYear()
      + '-' + (month < 10 ? '0' : '') + month
      + '-' + date.getDate()
      + ' ' + (hours < 10 ? '0' : '') + hours
      + ':' + (minutes < 10 ? '0' : '') + minutes;
  }

  savePrescription() {
    let formData: any = ObjectUtils.clone(this.prescription);
    formData['author_id'] = this.authService.getUser().id;
    
    formData.prescription_items.forEach(item => {
      item['initial_date'] = this.extractDate(item['initial_date']);
      item['final_date'] = this.extractDate(item['final_date']);
    });

    this.prescriptionService.savePrescription(formData).subscribe(response => {
      let msg = 'Não foi possível realizar cadastro de prescrição';

      if(response.success) {
        msg = 'Prescrição cadastrada com sucesso';
        this.prescription = {prescription_items: [{}]};
      }

      this._snackBar.open(msg, '', {
        duration: 2000,
        verticalPosition: 'top'
      });
    })
  }
}
