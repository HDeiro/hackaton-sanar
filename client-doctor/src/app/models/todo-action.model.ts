export class TodoAction {

    label: string;
    callback: Function;

    constructor({label, callback}) {
        this.label = label;
        this.callback = callback;
    }
}
