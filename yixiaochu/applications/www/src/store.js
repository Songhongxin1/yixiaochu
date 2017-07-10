export default {
    fetch(key){
        return JSON.parse(window.localStorage.getItem(key) || '[]');
    },
    save(items, key){
        window.localStorage.setItem(key,JSON.stringify(items));
    },
    remove(key){
    	window.localStorage.removeItem(key);
    }
}
