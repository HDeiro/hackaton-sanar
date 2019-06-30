import { User } from './user.model';
import { TodoAction } from './todo-action.model';

export class Todo {

    title: string = null;
    content: string = null;
    author: User = null;
    createdAt: Date = null;
    actions: Array<TodoAction> = null;
    
}
