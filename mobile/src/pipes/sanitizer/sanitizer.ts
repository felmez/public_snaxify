import { Pipe, PipeTransform } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';

@Pipe({name: 'sanitizer'})
export class Sanitizer implements PipeTransform {

  constructor(private sanitizer: DomSanitizer) {
  }

  transform(value: any, args: string = 'url'): any {
    switch (args) {
      case 'html': {
        return this.sanitizer.bypassSecurityTrustHtml(value);
      }
      case 'style': {
        return this.sanitizer.bypassSecurityTrustStyle(value);
      }
      case 'script': {
        return this.sanitizer.bypassSecurityTrustScript(value);
      }
      case 'resource': {
        return this.sanitizer.bypassSecurityTrustResourceUrl(value);
      }
      case 'url':
      default: {
        return this.sanitizer.bypassSecurityTrustUrl(value);
      }
    }
  }

}
