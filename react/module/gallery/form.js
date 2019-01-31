import React,{Component} from "react";


export default class Form extends Component {

    constructor(props) {
        super(props);
        this.state = {
            showForm : this.props.form,
        }
    }

    render() {
        //return <this.props.react />
        return (
            <form method={'post'} action={'text'} onSubmit={this.sendForm} name={'addCommentForm'}>
                {this.props.text != undefined ? <h2>Оставить комментарий</h2> : null}
                <div className={'addCommentForm'} >
                    <div className={'col-md-8 col-sm-8 fieldForm'}>
                        <textarea id={'content'} name={'content'} defaultValue={this.props.user!=undefined ? this.props.user : ''}></textarea>
                    </div>
                    <div className={'col-md-4 col-sm-4 fieldButton'}>
                        <input type={'submit'} name={'submit'} value={'Ответить'} />
                        <input type={'button'} name={'reset'} value={'Отмена'} onClick={this.props.hide} />

                    </div>
                </div>
            </form>
        )
    }


    // componentWillReceiveProps(prevProps, prevState) {
    //     console.log('componentDidUpdate')
    //         //if(prevState.)
    //         this.setState({showForm: this.props.form});
    //
    //     // if(prevProps.someValue!==this.props.someValue){
    //     //     //Perform some operation here
    //     //     this.setState({someState: someValue});
    //     //     this.classMethod();
    //     // }
    // }





    sendForm =(e)=> {
        e.preventDefault();
        let form = new FormData(e.currentTarget); //e.currentTarget
        let id = e.currentTarget.parentNode.getAttribute('data-id')!=null ? e.currentTarget.parentNode.getAttribute('data-id') : 0;
        let parent = e.currentTarget.parentNode.getAttribute('data-parent')!=0 ? e.currentTarget.parentNode.getAttribute('data-parent') : 0;
        if(form.get('content').length==0){
            this.props.message('Форма не может быть пустой')
            return false
        }

        this.props.submit(form.get('content'),id,parent);

    }


}