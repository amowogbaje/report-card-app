# Easy Toast
**easy toast** - is a vanilla javascript library for notifications.
<hr>
The purpose of this library is education.
I will be glad to your commits and code reviews in general!

The library weighs little, does not require css and is very easy to connect.

## Install via tag `<script>`:

Download `dist/toast.with.css.js` from [releases page](https://github.com/cr1gger/easy-toast/releases)

Connect to the head tag:
```html
<script src="toast.with.css.js"></script>
```

## Install via NPM:
Run:
```bash
npm install easy-v-toast
```
At the place of use:
```javascript
import Toast from "easy-v-toast/src/js/toast";
import "easy-v-toast/dist/toast.min.css";

const toast = new EasyToast({
  // Configuration
})

```
## Usage

#### Default options and types notification
```javascript
toast.success("Hello it's easy success toast!")

toast.warning("Hello it's easy warning toast!")

toast.danger("Hello it's easy danger toast!")

toast.dark("Hello it's easy dark toast!")

toast.notify("Hello it's easy default toast!")

```

#### Custom options, if connected via tag `<script>`
```javascript
let config = {
    duration: 10,
    position: 'bottom-center',
    hasCloseButton: false
}

toast.configure(config)

toast.notify("Hello it's easy default toast, with custom options!") 

toast.notify("Hello it's easy success toast, with custom options!") 
```

#### Custom options, if connected via NPM
```javascript
let config = {
    duration: 5,
    events: {
        click: (e) => {
            console.log('Your event click by notification!')
        }
    }
}

const toast = new EasyToast(config)

toast.dark('Dark notification, with custom options and events')
```

## Configuration
```javascript
const defaultConfig = {
    duration: 3,
    position: 'bottom-right',
    hasCloseButton: true,
    showTimeline: true,
    autoclose: true,
    stopOnHover: true,
    events: {
        'click': null,
        'closeClick': null,
    }
}
```

#### There are two ways to set the configuration:

First via constructor:
```javascript
  const toast = new EasyToast(config)
```

The second way, through the configure method:
```javascript
  toast.configure(config)
```

#### Available properties:
- `duration` - Duration in seconds
- `position` - top-right
  | top-middle
  | top-left
  | bottom-left
  | bottom-middle
  | bottom-right
- `hasCloseButton` - Visible close button | boolean
- `showTimeline` - Visible progress bar | boolean
- `autoclose` - Autoclose after the end of the timer | boolean
- `stopOnHover` - Pause the timer when you hover over a notification | boolean
- `events` - Object contains two available event: click and closeClick

### Version: 1.0.0
