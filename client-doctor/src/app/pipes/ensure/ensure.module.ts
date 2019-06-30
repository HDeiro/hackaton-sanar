import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { EnsurePipe } from './ensure.pipe';

@NgModule({
  declarations: [
    EnsurePipe
  ],
  imports: [
    CommonModule
  ],
  exports: [
    EnsurePipe
  ]
})
export class EnsureModule { }
