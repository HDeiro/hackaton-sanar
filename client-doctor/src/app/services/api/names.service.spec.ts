import { TestBed } from '@angular/core/testing';

import { NamesService } from './names.service';

describe('NamesService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: NamesService = TestBed.get(NamesService);
    expect(service).toBeTruthy();
  });
});
