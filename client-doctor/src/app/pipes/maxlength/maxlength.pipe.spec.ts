import { MaxlengthPipe } from './maxlength.pipe';

describe('MaxlengthPipe', () => {
  it('create an instance', () => {
    const pipe = new MaxlengthPipe();
    expect(pipe).toBeTruthy();
  });
});
