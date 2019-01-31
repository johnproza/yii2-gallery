import React,{Component} from "react";
import ReactDOM from 'react-dom';
let topCount = 0;
let topId = 0;

export default class Vote extends Component {

    constructor(props){
        super(props);
        this.state = {
            id:this.props.id, //id элемента
            like:this.props.like,
            containerId:0,
            dislike:this.props.dislike,

        }

        console.log('--------------------render vote------------------------')
    }


    handleClick = (e) => {

        if(e.currentTarget.classList.contains('like')){

            this.props.update(this.state.id, +this.state.like+1, null);
        }
        else {
            this.props.update(this.state.id, null ,+this.state.dislike+1);
        }



    }


    handleMessage = (e) => {
        this.props.message('Только авторизованные пользователи могут оценивать информацию')
    }


    render(){

        return (
            <div>
                <i onClick={this.props.userCan ? this.handleClick : this.handleMessage} className="icon like ion-md-thumbs-up" data-type="true"><span>{this.state.like}</span></i>
                <i onClick={this.props.userCan ? this.handleClick : this.handleMessage} className="icon dislike ion-md-thumbs-down" data-type="true"><span>{this.state.dislike}</span></i>
            </div>
        )
    }

    componentDidMount(){
        this.setState({
            containerId: ReactDOM.findDOMNode(this).parentNode,
            id: ReactDOM.findDOMNode(this).parentNode.getAttribute('data-id'),
            status:true
        });

        console.log('vote did mount')
    }

    componentWillReceiveProps(nextProps) {
        // Any time props.email changes, update state.
        if (nextProps.like != this.state.like) {
            console.log("like", nextProps.like != this.state.like)
            console.log(nextProps,this.state)
            this.setState({
                like: nextProps.like
            });
        }

        if (nextProps.dislike != this.state.dislike) {
            console.log("dislike", nextProps.dislike != this.state.dislike)
            console.log(nextProps,this.state)
            this.setState({
                dislike: nextProps.dislike
            });
        }
    }

}