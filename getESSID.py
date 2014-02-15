#!/usr/bin/env python

def getMacEssid(interface):

        import commands
        rawList=commands.getoutput("iwlist "+interface+" scanning").replace(" ",'')
        nCell=1
        x=""
        nList=""
        nSearch=0
        macList=list()
        lEssid=list()
        macListIndex=0
        finalList=list()
        channelList=list()
        for i in range(50):  #search output of iwlist scanning command for MAC, ESSID, and channel of AP.
                nSearch=rawList.find("Cell0"+str(nCell)+"-Address")
                eSearch=nSearch
                cSearch=eSearch
                cList=rawList[cSearch+41:cSearch+43]
                cList=cList.strip('\n')
                channelList.append(cList)
                essidList=rawList[eSearch:eSearch+181]
                essidListNum=essidList.find("ESSID:")
                essidList=essidList[essidListNum:(essidList.find('"\n'))]
                essidList=essidList.replace('ESSID:"','')
                lEssid.append(essidList)
                macList.append(nSearch)
                macList[macListIndex]=rawList[macList[macListIndex]:macList[macListIndex]+32]
                if macList[macListIndex]!='':
                #print 'hello'
                     macList[macListIndex]=macList[macListIndex].replace('Cell0','')
                     macList[macListIndex]=macList[macListIndex].lstrip(str(nCell))
                     macList[macListIndex]=macList[macListIndex].lstrip("-Address:")
                else:
                         macList.remove('')
                         lEssid.remove('')
                         break
                nCell=nCell+1
                macListIndex=macListIndex+1
        x=0
        for i in range(macListIndex):
                finalList.append(channelList[x]+'/'+lEssid[x]+"|"+macList[x])
                x=x+1
        print '\n',finalList,'\n'
        return finalList
interface=raw_input('Enter the name of the wireless interface: ')
getMacEssid(interface)
