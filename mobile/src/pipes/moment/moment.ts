import { Pipe, PipeTransform } from '@angular/core';
import * as moment from 'moment';

@Pipe({name: 'moment',})
export class MomentPipe implements PipeTransform {
  transform(value: string, args: string = 'toDate') {
    switch (args) {
      case 'toDate':
      default: {
        return moment(value).toDate();
      }
    }
  }
}
