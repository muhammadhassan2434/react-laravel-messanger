import { usePage } from "@inertiajs/react";
import { useEffect } from "react";

const ChatLayout = ({ children }) => {
    const page = usePage();
    const conservations = page.props.conservations;
    const selectedConservations = page.props.selectedConservations;
    console.log("conservations: ", conservations);
    console.log("selectedConservations: ", selectedConservations);

    useEffect(() =>{
        Echo.join("online")
        .here((users) => {
            console.log('here', users)
        })
        .joining((user)=>{
            console.log('joining',user);
        })
        .leaving((user) =>{
            console.log('leaving', user)
        })
        .error((error) => {
            console.log('error', error)
        });

         return () => {
             Echo.leave('online');
         }
    },[]);
    return (
        <>
            Chat layout
            <div>{children}</div>
        </>
    );
};

export default ChatLayout;
