import { Component, Input } from '@angular/core';

/**
 * Generated class for the ChamferedCardItemComponent component.
 *
 * See https://angular.io/api/core/Component for more info on Angular
 * Components.
 */
@Component({
  selector: 'chamfered-card-item',
  templateUrl: 'chamfered-card-item.html'
})
export class ChamferedCardItemComponent {
  @Input() image = null;
  @Input() title = null;
  @Input() timestamp = null;
  @Input() subTitle = null;
  @Input() badge = null;
  @Input() rating = null;

  constructor() {
  }


}
