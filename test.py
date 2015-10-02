

## open the file

try:
   f = open("/Users/fidelis/Downloads/sequence.txt")
except IOError:
   print("file does not exist or could not be opened")

#create Dictionary
seqs= {}

#loop through file f and get the sequences

for line in f: # for every line in f do the following
    line = line.rstrip() #discards new line at the end if any

    #distinguish the header from the sequence
    if line.startswith('>'):  # if first character of line is equal > then its the header. alternatively one could
                             # use line.startswith('>')
                        
        words=line.split()   #splits the line into words
        name=  words[0][1:]   # get the first word and not the '>' sign
        seqs[name]=''         #assign the name to the dictionary and give a null sequence
   
    else:                    # we now have a sequence and not a header so we read the sequence

    # read the sequence and assign it to the name
        seqs[name] = seqs[name]+ line

f.close() # close file

#for name, seq in seqs.items(): # loops through dict and store id and values in item()
# print(name,seq)     # print every dictionary id(key) and the associated value
'''
gen_code = {'stop':'UUU', 'lysine':'AAA'}
for name, i in gen_code.items():
    print(name , i)
'''






























'''
dna = "AGTGTGGGCG"

def reverse_string(seq):
    " function to reverse a string "
    return seq[::-1]

def complement(dna):
       " takes a dna seq as a parameter and assing its complement"

       #create dictionary of DNA   complementary base pairs
       basecomplement= {'A':'T', 'C':'G', 'T':'A', 'G':'C'}

       #convert dna string to list
       letters = list(dna)

       #use dictionary to assign every element in the list its complement

       #for every element in the list of letters, assign to it is complement from the dictionary
       letters = [basecomplement[base] for base in letters]

       #join() converts the list of letters to a string and the '' means separate by space
       return ''.join(letters)


def reversecomplement(seq):

        "reverse a sequences and the base pair complements it"
        seq = reverse_string(seq)
        seq = complement(seq)
        return seq


#--- function call

rev_oupt = reversecomplement(dna)
print("The reverse complement of your sequence is : \n")
print (rev_oupt)
'''


'''
def has_stop_codon(dna):
    "this function checks for a stop codon in a sequence"
    stop_codon_found = false
    stop_codons = ['tga','tag','taa']
    for i in range(0,len(dna), 3):
        codon = dna[i:i+3].Lower()
        if codon in stop_codons :
              stop_codon_found = true
              break


dna = raw_input("enter dna sequence")
if(has_stop_codon(dna)):
    print("sequence has a stop codon")
else:
    print("sequence has no stop codon")

'''


#-------------------------------------------------------------
'''
sequence = 'GAAGCGCA'

def check_stp_cdn(seq):
    if 'UAG' or 'uag' in seq:
        print ("contains stop codon UAG")
    elif 'UAA' or 'uaa' in seq:
        print ("contains stop codon UAA")
    elif 'UGA' or 'uga' in seq:
        print("contains stop codon UGA")
    else:
        print("sequence contains no stop codon")



check_stp_cdn(sequence)
'''

'''
var = 100
if var == 200:
    print "1 - Got a true expression value"
    print var
elif var == 150:
    print "2 - Got a true expression value"
    print var
elif var == 100:
    print "3 - Got a true expression value"
    print var
else:
    print "4 - Got a false expression value"
    print var


print "Good bye!"
'''


'''
dna = raw_input("enter dna seq ");

'''

