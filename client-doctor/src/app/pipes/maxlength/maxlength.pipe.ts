import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'maxlength'
})
export class MaxlengthPipe implements PipeTransform {

  transform(value: any, max: number): any {
    value = value.changingThisBreaksApplicationSecurity || value;
    max = max || 100;
    return value.substring(0, max) + (value.length > max ? '...' : '');
  }

}
