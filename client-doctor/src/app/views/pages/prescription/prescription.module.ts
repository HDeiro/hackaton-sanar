import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PrescriptionRoutingModule } from './prescription.routing.module';
import { PrescriptionComponentModule } from './prescription/prescription.component.module';

@NgModule({
  imports: [
    CommonModule,
    PrescriptionComponentModule,
    PrescriptionRoutingModule
  ]
})
export class PrescriptionModule { }
