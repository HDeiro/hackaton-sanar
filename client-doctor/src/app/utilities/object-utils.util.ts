export abstract class ObjectUtils {
    static clone(obj: object): object {
        return JSON.parse(JSON.stringify(obj));
    }    
}
