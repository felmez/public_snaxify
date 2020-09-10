import { NgModule } from '@angular/core';
import { TruncatePipe } from './truncate/truncate';
import { ECurrencyPipe } from './ecurrency/ecurrency';
import { Sanitizer } from './sanitizer/sanitizer';
import { MomentPipe } from './moment/moment';

@NgModule({
  declarations: [
    TruncatePipe,
    ECurrencyPipe,
    Sanitizer,
    MomentPipe
  ],
  imports: [],
  exports: [
    TruncatePipe,
    ECurrencyPipe,
    Sanitizer,
    MomentPipe
  ]
})
export class PipesModule {
}
