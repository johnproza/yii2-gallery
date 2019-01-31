import React,{Component} from "react";
import ReactDOM from 'react-dom';
import Vote from '../vote/index';
import Ajax from "../ajax";
import Form from "./form";

export default class Item extends Component {

    constructor(props) {
        super(props);
        this.state = {
            data : this.props.data,
            showForm : this.props.form,
            like:this.props.data.like,
            dislike:this.props.data.dislike,
            userAnswer:null
        }
    }

    render() {

        return (
            <div className={this.props.classElem} data-id={this.state.data.id} data-parent={this.state.data.parent}>
                <div className="user">
                    <img src={this.state.data.avator} alt={this.state.data.author} />
                </div>
                <div className="message">
                    <div className="systemCommnet">
                        <div className="authorInfo">
                            <b>{this.state.data.author}</b><span>{new Date(this.state.data.created_at*1000).toLocaleString('en-US')}</span>
                            {this.props.userCan ? <span  className={'answer'} onClick={this.formToggle}>Ответить</span> : null }
                        </div>
                        <div className="like vote" data-id={this.state.data.id} data-parent={this.state.data.parent} data-like={this.state.data.like}
                             data-dislike={this.state.data.dislike}>
                            {<Vote update={this.updateItem}
                                      id={this.state.data.id}
                                      like={this.state.like}
                                      dislike={this.state.dislike}
                                      userCan={this.props.userCan}
                                      message={this.props.message}
                                      vote = {this.props.vote}
                                />}
                        </div>
                    </div>
                    <div className="post" dangerouslySetInnerHTML={{__html: this.replaceContent()}} />

                </div>

                {this.state.showForm ? <Form submit={this.props.submit } message={this.props.message} hide={this.formHide} user={this.state.userAnswer}/>:null}
            </div>
        )
    }


    componentWillReceiveProps(prevProps, prevState) {

        if(this.props.form!=this.state.showForm){
            setTimeout(() => {
                this.setState({
                    showForm: this.props.form,
                });
            },3000)

        }
    }

    updateItem = (id,like,dislike) =>{
        console.log(id,like,dislike);
        Ajax({
            "url":`/comments/default/vote`,
            "method":'GET',
            "csrf":true,
            "data":{
                "id":id,
                "like":like,
                "dislike":dislike,
            }
        }).then(res =>{
            if(res.response.status){
                like !=null ?
                this.setState({
                    like:like,
                }): this.setState({
                        dislike:dislike
                    })

                this.props.message(res.response.message)
            }
            else {
                this.props.message(res.response.message)
            }



            if(NODE_ENV==="development") {
                console.log('------like update-------',res.response);
            }
        })
    }

    formToggle = (e) =>{
        let user = e.currentTarget.parentNode.children[0].innerHTML;
        console.log(user)
        this.setState(()=> {
            return {
                showForm:true,
                userAnswer:`*${user}*, `
            }
        })
    }

    replaceContent = () =>{
        return this.props.data.content.replace(/\*\S{1,}\*/gi, function(match,p,d){
            return "<span class='answer'>"+match.slice(1,match.length-1)+"</span>";

        })
    }

    formHide = () =>{

        this.setState(()=> {
            return {showForm:false}
        })
    }


}