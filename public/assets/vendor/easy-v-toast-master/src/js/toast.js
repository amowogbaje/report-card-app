// Stack position classes
const STACK_CLASS_TL = 'easy-toast-stack-tl'
const STACK_CLASS_TR = 'easy-toast-stack-tr'
const STACK_CLASS_TM = 'easy-toast-stack-tm'
const STACK_CLASS_BR = 'easy-toast-stack-br'
const STACK_CLASS_BL = 'easy-toast-stack-bl'
const STACK_CLASS_BM = 'easy-toast-stack-bm'
const STACK_CLASS_CENTER = 'easy-toast-stack-center'
const TIMELINE_CLASS = 'easy-toast-timeline'

// Positions
const POSITION_TR = 'top-right'
const POSITION_TM = 'top-middle'
const POSITION_TL = 'top-left'
const POSITION_BL = 'bottom-left'
const POSITION_BM = 'bottom-middle'
const POSITION_BR = 'bottom-right'
const POSITION_CENTER = 'center'

// Types
const TYPE_DEFAULT = 'default'
const TYPE_SUCCESS = 'success'
const TYPE_DANGER = 'danger'
const TYPE_WARNING = 'warning'
const TYPE_DARK = 'dark'

const DEFAULT_CONFIG = {
    duration: 3,
    type: 'default',
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

function runNotify(message, cfg = {}) {
    let config = {...DEFAULT_CONFIG, ...cfg }

    let stack = getStack(config.position)
    let { notify, notifyClose, notifyTimeline } = createNotify(message, config)

    if (config.stopOnHover) {
        notify.onmouseenter = function() {
            notify.setAttribute('data-pause', 'pause');
        }
        notify.onmouseleave = function() {
            notify.removeAttribute('data-pause');
            let startTime = notify.getAttribute('data-start')
            let lastTime = notify.getAttribute('data-last')

            startAnimate(notify, config, (lastTime - startTime), notifyTimeline.style.width.replace('%', ''))
        }
    }

    stack.prepend(notify)

    let animateId = startAnimate(notify, config)

    // Register event close click
    if (config.hasCloseButton) {
        if (typeof config.events.closeClick === 'function')
        {
            notifyClose.onclick = function(e) {
                e.stopPropagation();
                config.events.closeClick(e);
            }
        } else {
            notifyClose.onclick = (e) => {
                e.stopPropagation();
                destroy(notify, animateId)
            }
        }
    }

    // Register event notify click
    if (typeof config.events.click === 'function')
    {
        notify.onclick = function(e) {
            e.stopPropagation();
            config.events.click(e);
        }
    }
}

function startAnimate(notify, config, startDuration = null, startPercent = null) {
    notify.setAttribute('data-start', Date.now())

    let duration = startDuration ?
        config.duration * 1000 - startDuration : config.duration * 1000

    let percent = nullOperation(startPercent, 100)


    let animateId = animate({
        timing: function(timeFraction) {
            return percent - (timeFraction * 100)
        },
        draw: (progress) => {
            if (config.showTimeline && config.autoclose) {
                notify.setAttribute('data-last', Date.now())
                notify.querySelector(`.${TIMELINE_CLASS}`).style.width = progress + '%';
            }
            if (progress < 1) {
                if (config.autoclose) {
                    destroy(notify, animateId)
                }
            }
        },
        duration,
        notify
    })

    return animateId;
}

function nullOperation(value, defaultValue) {
    if (value) {
        return value;
    }
    if (defaultValue)
    {
        return defaultValue
    }

    return null;
}

function createNotify(text, config) {
    let typeClass = getTypeClass(config.type)
    let timeLineBg = getTimelineClass(config.type)

    let notifyBlock = document.createElement('div');
    notifyBlock.className = 'easy-toast easy-toast-block ' + typeClass

    let notifyFlex = document.createElement('div');
    notifyFlex.className = 'easy-toast et-p-4 et-flex'

    let notifyTitle = document.createElement('p')
    notifyTitle.className = 'easy-toast et-px-3'
    notifyTitle.innerHTML = text.toString().replaceAll('script', '')

    let notifyContainer = document.createElement('div')
    notifyContainer.className = 'easy-toast et-ml-auto'

    let notifyClose = document.createElement('button')
    notifyClose.className = 'easy-toast easy-toast-button'

    notifyClose.innerHTML = `
        <span class="easy-toast et-sr-only">Close</span>
        <svg class="easy-toast easy-toast-svg-close" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.92524 0.687069C1.126 0.486219 1.39823 0.373377 1.68209 0.373377C1.96597 0.373377 2.2382 0.486219 2.43894 0.687069L8.10514 6.35813L13.7714 0.687069C13.8701 0.584748 13.9882 0.503105 14.1188 0.446962C14.2494 0.39082 14.3899 0.361248 14.5321 0.360026C14.6742 0.358783 14.8151 0.38589 14.9468 0.439762C15.0782 0.493633 15.1977 0.573197 15.2983 0.673783C15.3987 0.774389 15.4784 0.894026 15.5321 1.02568C15.5859 1.15736 15.6131 1.29845 15.6118 1.44071C15.6105 1.58297 15.5809 1.72357 15.5248 1.85428C15.4688 1.98499 15.3872 2.10324 15.2851 2.20206L9.61883 7.87312L15.2851 13.5441C15.4801 13.7462 15.588 14.0168 15.5854 14.2977C15.5831 14.5787 15.4705 14.8474 15.272 15.046C15.0735 15.2449 14.805 15.3574 14.5244 15.3599C14.2437 15.3623 13.9733 15.2543 13.7714 15.0591L8.10514 9.38812L2.43894 15.0591C2.23704 15.2543 1.96663 15.3623 1.68594 15.3599C1.40526 15.3574 1.13677 15.2449 0.938279 15.046C0.739807 14.8474 0.627232 14.5787 0.624791 14.2977C0.62235 14.0168 0.730236 13.7462 0.92524 13.5441L6.59144 7.87312L0.92524 2.20206C0.724562 2.00115 0.611816 1.72867 0.611816 1.44457C0.611816 1.16047 0.724562 0.887983 0.92524 0.687069Z" fill="currentColor"/>
        </svg>
        `


    let notifyTimeline = document.createElement('div')
    notifyTimeline.className = `easy-toast ${timeLineBg} ${TIMELINE_CLASS}`

    notifyFlex.append(notifyTitle)

    if (config.hasCloseButton) {
        notifyContainer.append(notifyClose)
    }

    notifyFlex.append(notifyContainer)
    notifyBlock.append(notifyFlex)

    if (config.showTimeline && config.autoclose) {
        notifyBlock.append(notifyTimeline)
    }

    return {
        notify:notifyBlock,
        notifyClose,
        notifyTimeline
    };

}

function getStack(position) {
    let positionClass = getPositionClasses(position)
    let stackClass = getStackClass(position)

    let stack = document.querySelector('.' + stackClass)
    if (!stack)
    {
        let stackContainer = document.createElement('div')
        stackContainer.className = 'easy-toast et-fixed ' + positionClass

        stack = document.createElement('div')
        stack.className = 'easy-toast easy-toast-stack ' + stackClass;

        stackContainer.append(stack)

        document.body.append(stackContainer)
    }
    return stack;
}

function destroy(block, animateId = null) {
    block.remove()
    if (animateId) {
        cancelAnimationFrame(animateId)
    }
}

function getPositionClasses(position) {
    switch (position) {
        case POSITION_TL: return 'easy-toast-position-top-left';
        case POSITION_TM: return 'easy-toast-position-top-middle';
        case POSITION_TR: return 'easy-toast-position-top-right';

        case POSITION_BL: return 'easy-toast-position-bottom-left';
        case POSITION_BM: return 'easy-toast-position-bottom-middle';
        case POSITION_BR: return 'easy-toast-position-bottom-right';
        case POSITION_CENTER: return 'easy-toast-position-center';
        default: return 'easy-toast-position-bottom-right'

    }
}

function getStackClass(position) {
    switch (position) {
        case POSITION_TL: return STACK_CLASS_TL;
        case POSITION_TM: return STACK_CLASS_TM;
        case POSITION_TR: return STACK_CLASS_TR;
        case POSITION_BL: return STACK_CLASS_BL;
        case POSITION_BM: return STACK_CLASS_BM;
        case POSITION_BR: return STACK_CLASS_BR;
        case POSITION_CENTER: return STACK_CLASS_CENTER;
        default: return STACK_CLASS_BR;
    }
}

function getTypeClass(type) {
    switch (type) {
        case TYPE_DEFAULT: return 'et-bg-gray-500';
        case TYPE_SUCCESS: return 'et-bg-green-500';
        case TYPE_DANGER: return 'et-bg-red-500';
        case TYPE_WARNING: return 'et-bg-yellow-500';
        case TYPE_DARK: return 'et-bg-gray-900';
    }
}

function getTimelineClass(type) {
    switch (type) {
        case TYPE_DEFAULT: return 'et-bg-gray-900';
        case TYPE_SUCCESS: return 'et-bg-green-900';
        case TYPE_DANGER: return 'et-bg-red-900';
        case TYPE_WARNING: return 'et-bg-yellow-900';
        case TYPE_DARK: return 'et-bg-gray-500';
    }
}

const animate = ({timing, draw, duration, notify}) => {

    let start = performance.now();

    return requestAnimationFrame(function animate(time) {

        if (notify.getAttribute('data-pause')) return;

        // timeFraction изменяется от 0 до 1
        let timeFraction = (time - start) / duration;
        if (timeFraction > 1) timeFraction = 1;
        // вычисление текущего состояния анимации
        let progress = timing(timeFraction);

        draw(progress); // отрисовать её

        if (timeFraction < 1) {
            return requestAnimationFrame(animate);
        }

    });
}


function EasyToast (configuration = {}) {

    this.configuration = configuration
}

EasyToast.prototype.success = function(message) {
    let config = {...this.configuration, type: 'success' }
    runNotify(message, config);
}

EasyToast.prototype.warning = function(message) {
    let config = {...this.configuration, type: 'warning' }
    runNotify(message, config);
}

EasyToast.prototype.danger = function(message) {
    let config = {...this.configuration, type: 'danger' }
    runNotify(message, config);
}

EasyToast.prototype.dark = function(message) {
    let config = {...this.configuration, type: 'dark' }
    runNotify(message, config);
}

EasyToast.prototype.notify = function(message) {
    let config = {...this.configuration, type: 'default' }
    runNotify(message, config)
}

EasyToast.prototype.configure = function(config) {
    this.configuration = config
}

export default EasyToast
