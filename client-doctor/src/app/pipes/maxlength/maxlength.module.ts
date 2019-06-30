import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MaxlengthPipe } from './maxlength.pipe';

@NgModule({
  declarations: [
    MaxlengthPipe
  ],
  imports: [
    CommonModule
  ],
  exports: [
    MaxlengthPipe
  ]
})
export class MaxlengthModule { }
