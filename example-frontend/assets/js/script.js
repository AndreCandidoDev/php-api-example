const BASE_URL = "http://localhost:8080/example"

const createData = async () =>
{
    const name = document.getElementById("name").value
    
    const description = document.getElementById("description").value
    
    console.log(name)

    if(name !== "" && description !== "")
    {
        const requestData = {
            name: name,
            description: description
        }

        const result = await fetch(BASE_URL, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })

        if(result.ok)
        {
            const response = await result.json()
            console.log(response)

            document.getElementById("name").value = ""
            document.getElementById("description").value = ""

            await getAll()
        }
    }
}

const deleteData = async (id) =>
{
    console.log("delete")

    const result = await fetch(`${BASE_URL}/${id}`, { method: "DELETE" })

    if(result.ok)
    {
        const response = await result.json()
        
        const data = response.data
        console.log(data)

        await getAll()
    }
}


const getAll = async () => 
{
    const result = await fetch(BASE_URL)
    
    if(result.ok)
    {
        const response = await result.json()
        
        const data = response.data

        const ul = document.getElementById('registers')

        ul.className = "registers"

        ul.innerHTML = ""

        for(let i = 0; i < data.length; i++)
        {
            const li = document.createElement("li")
 
            const pText = document.createElement("p")

            const pRemove = document.createElement("p")

            pText.textContent = data[i].name + " - " + data[i].description

            pRemove.textContent = "Remover"

            pRemove.onclick = () => deleteData(data[i].id) 

            li.appendChild(pText)
            li.appendChild(pRemove)
            li.className = "item"

            ul.appendChild(li)
        }
    }
}

getAll()