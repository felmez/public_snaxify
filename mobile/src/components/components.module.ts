import { NgModule } from '@angular/core';
import { ChamferedCardItemComponent } from './chamfered-card-item/chamfered-card-item';
import { CommonModule } from '@angular/common';
import { PipesModule } from '../pipes/pipes.module';
import { ArticleContentComponent } from './article-content/article-content';

@NgModule({
  declarations: [
    ChamferedCardItemComponent,
  ],
  imports: [
    PipesModule,
    CommonModule
  ],
  exports: [
    ChamferedCardItemComponent,
  ]
})
export class ComponentsModule {
}
