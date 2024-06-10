

// * Icon
import angleDownIcon from  "../../img/icons/angle-down-blue.svg";
import searchIcon from   "../../img/icons/search.svg"

const KEY_ARROWS = {
    ENTER: 13,
    ESCAPE: 27,
    UP: 38,
    DOWN: 40
};

const BaseSelectGeneric = {
    delimiters: ["[[", "]]"],
    props: {
        value: {
            required: true
        },
        options: {
            type: Array | Object,
            required: true
        },
        disabled: {
            type: Boolean,
            default: false
        },  
        defaultValue: {
            type: [String, Number],
            default: ""
        },
        searchAvailable:{
            type:Boolean,
            default:false,
        }
    },
    data: function() {
        return {
            angleDownIcon,
            optionIndex: -1,
            focus: false,

            searchIcon,

            filter_template_text:''
        };
    },
    computed: {
        noOptions: function () {
            return this.filteredOptions.templates.length;
        },
        isObject: function() {
            return !!this.options.templates;
        },
        filteredOptions: function() {
            if(this.searchAvailable){
                return {
                    templates:this.templates.filter(option=>{
                        return option.toLowerCase().includes(this.filter_template_text.toLowerCase())
                    })
                }
            }else{
                return {
                    templates: this.templates
                };
            }
        },
        templates: function () {
            if (this.defaultValue) {
                return this.isObject ?  [this.defaultValue, ...this.options.templates] : [this.defaultValue, ...this.options];
            } else {
                return this.isObject ?  [...this.options.templates] : [...this.options];
            }
        },
        values: function () {
            if (this.defaultValue) {
                return this.isObject ? [null, ...this.options.values] : [null,...this.options];
            } else {
                return this.isObject ? [...this.options.values] : [...this.options];
            }
        },
        localValue: function() {
            if (this.isObject) {
                if(this.value){ //*if have value , set 
                    return { template: this.value.label }; //! if is object only render the if the text value is called label
                }else{
                    const index = this.values.indexOf(this.value);
                    return { template: this.templates[index] };
                }
            } else {
                return this.value;
            }
        },
    },
    methods: {
        blur: function() {
            this.focus = false;
        },
        setOption: function(index) {
            const value = this.filteredOptions.templates[index];
            const valueIndex = this.templates.indexOf(value);
            this.$emit("input", this.values[valueIndex]);
            this.blur();
        },
        onKeyListener: function(event) {
            const { keyCode } = event || window.event;

            if (keyCode === KEY_ARROWS.UP) {
                this.optionIndex = Math.max(this.optionIndex - 1, 0);
                event.preventDefault();
            } else if (keyCode === KEY_ARROWS.DOWN) {
                this.optionIndex = Math.min(
                    this.optionIndex + 1,
                    this.filteredOptions.length - 1
                );
                event.preventDefault();
            } else if (keyCode === KEY_ARROWS.ENTER) {
                if (this.noOptions) this.setOption(this.optionIndex);
            } else if (keyCode === KEY_ARROWS.ESCAPE) {
                this.blur();
            }
        }
    },
    watch: {
        focus(newValue) {
            if (newValue) {
                this.optionIndex = -1;
                document.addEventListener("keydown", this.onKeyListener);
            } else {
                if (this.searchAvailable) this.filter_template_text=''
                document.removeEventListener("keydown", this.onKeyListener);
            }
        },
        value(newValue, oldValue) {
            //console.log(newValue, oldValue)
            if(newValue !== oldValue){
                this.$emit("update-value", newValue);
            }
        }
    },
    template: `
      <div class="b-select-generic" :class="{ 'disabled': disabled }" v-clickaway="blur">
        <div class="b-select-generic__header" @click="focus = !focus"> 
            <slot name="value" :value="value">
                <template v-if="isObject">
                    <div v-html="localValue.template || defaultValue" :class="{'placeholder':!value}"></div>
                </template>
                <template v-else>
                    <div v-html="localValue || defaultValue" :class="{'placeholder':!value}"></div>
                </template>
            </slot>
            <img class="image" :src="angleDownIcon"/>
        </div>
        <div v-if="focus" class="b-select-generic__body">
            <template v-if="isObject">
                <div v-if="searchAvailable" class="field input-search-with-icon">
                    <p class="control has-icons-left">
                        <input v-model.trim="filter_template_text" autocomplete="off" class="input" type="text"
                        placeholder="Buscar" attr="template_text" >
                        <span class="icon is-small is-left"> <img  :src="searchIcon"/></i> </span>
                    </p>
                </div>
                <div class="b-select-generic__list">
                    <div 
                        class="b-select-generic__item" 
                        :class="{ 'b-select-generic__item--hover': index === optionIndex }" 
                        v-for="(option, index) in filteredOptions.templates" 
                        @click="setOption(index)"
                    >
                        <slot name="option" :option="option"> 
                            <div v-html="option"></div> 
                        </slot>
                    </div>
                    <div class="b-select-generic__item" v-if="!noOptions">No hay opciones</div>
                </div>
            </template>
            <template v-else>
                <div v-if="searchAvailable" class="field input-search-with-icon">
                    <p class="control has-icons-left">
                        <input v-model.trim="filter_template_text" autocomplete="off" class="input" type="text"
                        placeholder="Buscar" attr="template_text" >
                        <span class="icon is-small is-left"> <img  :src="searchIcon"/></i> </span>
                    </p>
                </div>
                <div class="b-select-generic__list">
                    <div 
                        class="b-select-generic__item" 
                        :class="{ 'b-select-generic__item--hover': index === optionIndex }" 
                        v-for="(option, index) in filteredOptions.templates" 
                        @click="setOption(index)"
                    >
                        <slot name="option" :option="option"> 
                            <div v-html="option"></div> 
                        </slot>
                    </div>
                    <div class="b-select-generic__item" v-if="!noOptions">No hay opciones</div>
                </div>
            </template>
        </div>
      </div>
    `
};

export default BaseSelectGeneric;
